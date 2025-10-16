<?php

use RohanAdhikari\NepaliDate\Traits\haveImmutable;
use RohanAdhikari\NepaliDate\Traits\useOverFlowBounds;

uses()->group('overflow-bounds');

class OverflowTestClass
{
    use haveImmutable;
    use useOverFlowBounds;
}

beforeEach(function () {
    OverflowTestClass::overflowGlobal(false);
    OverflowTestClass::setStrictMode(false);
    OverflowTestClass::resetOverflowSettings();
    $this->instance = new OverflowTestClass;
    $this->instance->resetOverflow();
});

it('can enable and disable global overflow', function () {
    expect(OverflowTestClass::isGlobalBoundActive('month'))->toBeFalse();
    OverflowTestClass::overflowGlobal(true);
    expect(OverflowTestClass::isGlobalBoundActive('month'))->toBeTrue();

    OverflowTestClass::overflowGlobal(false);
    expect(OverflowTestClass::isGlobalBoundActive('month'))->toBeFalse();
});

it('can enable and disable global bounds', function () {
    foreach (['month', 'day', 'weekday', 'hour', 'minute', 'second'] as $type) {
        OverflowTestClass::overflowGlobalBound($type, true);
        expect(OverflowTestClass::isGlobalBoundActive($type))->toBeTrue();
        OverflowTestClass::overflowGlobalBound($type, false);
        expect(OverflowTestClass::isGlobalBoundActive($type))->toBeFalse();
    }
});

it('can enable and disable local overflow', function () {
    $this->instance->overflowLocal(true);
    expect($this->instance->isOverflowActive())->toBeTrue();

    $this->instance->overflowLocal(false);
    expect($this->instance->isOverflowActive())->toBeFalse();
});

it('can enable and disable local bounds', function () {
    $this->instance->overflowLocal(true);

    foreach (['month', 'day', 'weekday', 'hour', 'minute', 'second'] as $type) {
        $this->instance->overflowBound($type, true);
        expect($this->instance->isBoundActive($type))->toBeTrue();

        $this->instance->overflowBound($type, false);
        expect($this->instance->isBoundActive($type))->toBeFalse();
    }
});

it('respects strict mode for global bounds', function () {
    OverflowTestClass::setStrictMode(true);
    OverflowTestClass::overflowGlobal(true);
    OverflowTestClass::overflowGlobalBound('minute', true);

    $this->instance->overflowLocal(true);
    $this->instance->overflowBound('minute', false);

    expect($this->instance->isBoundActive('minute'))->toBeTrue();
});

it('local bounds override global bounds when overflow is active', function () {
    OverflowTestClass::overflowGlobal(true);
    OverflowTestClass::overflowGlobalBound('second', true);

    $this->instance->overflowLocal(true);
    expect($this->instance->isBoundActive('second'))->toBeTrue();

    $this->instance->overflowBound('second', false);
    expect($this->instance->isBoundActive('second'))->toBeFalse();
});

it('resets instance and global settings properly', function () {
    OverflowTestClass::overflowGlobal(true);
    OverflowTestClass::overflowGlobalBound('month', true);
    $this->instance->overflowLocal(true)->overflowBound('month', true);
    $this->instance->resetOverflow();
    expect($this->instance->isLocalBoundActive('month'))->toBeNull();
    OverflowTestClass::resetOverflowSettings();
    expect($this->instance->isOverflowActive())->toBeFalse();
    expect(OverflowTestClass::isGlobalBoundActive('day'))->toBeFalse();
    expect(OverflowTestClass::isGlobalBoundActive('month'))->toBeFalse();
});

it('dynamic instance calls affect local overflow', function () {
    $this->instance->handleOverflowDynamicCall('hourOverflow', [true]);
    expect($this->instance->isLocalBoundActive('hour'))->toBeTrue();
    $this->instance->handleOverflowDynamicCall('hourOverflow', [false]);
    expect($this->instance->isLocalBoundActive('hour'))->toBeFalse();
});

it('dynamic static calls affect global overflow', function () {
    OverflowTestClass::handleOverflowDynamicStaticCall('minuteOverflow', [true]);
    OverflowTestClass::overflowGlobal(true);
    expect(OverflowTestClass::isGlobalBoundActive('minute'))->toBeTrue();
});
