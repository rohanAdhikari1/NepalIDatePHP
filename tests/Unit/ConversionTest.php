<?php

use RohanAdhikari\NepaliDate\Traits\DateConverter;

describe('conversion', function () {
    $class = new class
    {
        use DateConverter;
    };
    it('conver adtobs', function () use ($class) {
        $method = new ReflectionMethod($class, 'ADtoBS');
        $method->setAccessible(true);
        $date1 = $method->invoke($class, 2025, 10, 15);
        expect($date1)->toBe([2082, 6, 29]);
        $date2 = $method->invoke($class, 2005, 3, 28);
        expect($date2)->toBe([2061, 12, 15]);
    });

    it('convert bstoad', function () use ($class) {
        $method = new ReflectionMethod($class, 'BStoAD');
        $method->setAccessible(true);
        $date1 = $method->invoke($class, 2082, 6, 29);
        expect($date1)->toBe([2025, 10, 15]);
        $date2 = $method->invoke($class, 2061, 12, 15);
        expect($date2)->toBe([2005, 3, 28]);
    });
});
