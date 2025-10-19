# NepaliDate In Laravel

## Cast Attribute to NepaliDate

You can cast a date attribute to NepaliDate directly in your Laravel model.

1. Storing as AD Date but retreive in NepaliDate
   Use the `ADAsNepaliDate` cast when you want to store dates in the Gregorian calendar (AD) but retrieve them as NepaliDate (BS).

```php
use RohanAdhikari\NepaliDate\Laravel\Casts\ADAsNepaliDate;

class Post extends Model
{
    protected function casts(): array
    {
        return [
            'published_at' => ADAsNepaliDate::class,
        ];
    }
}

```

2. Storing in BS(Nepali) Date

> [!Warning]
> When storing BS dates, avoid using `date` or `datetime` column types in your database schema.
> `string` is recommended for accuracy.

```php
use RohanAdhikari\NepaliDate\Laravel\Casts\AsNepaliDate;

class Post extends Model
{
    protected function casts(): array
    {
        return [
            'published_date' => AsNepaliDate::class,
        ];
    }
}
```

**Usage Example:**
You can now use NepaliDate attributes in your controllers or views:

```php
$post = Post::firstOrcreate([
        'published_at' => NepaliDate::now(),
        'published_date' => '2082-07-08',
    ], [
        'title' => 'check 1',
        'body' => 'body1 ',
    ]);
    // Access NepaliDate attributes
    $post->published_at; // NepaliDate object
    $post->published_date; // NepaliDate object
```
