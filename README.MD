# ASPager

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

A library to split results into multiple pages

## Install

Via Composer

```bash
$ composer require alexandershevchuk/pager
```

## Usage

```php
$obj = new ASPager\DirPager(
    new ASPager\PageList(),
    'photos',
    3,
    2
);
```

```php
$obj = new ASPager\FilePager(
    new ASPager\ItemsRange(),
    'largetextfile.txt'
);
echo "<pre>";
print_r($obj->getItems());
echo "</pre>";
echo "<p>$obj</p>";
```

```php
try{
    $pdo = new PDO(
        'mysql:host=localhost;dbname=test',
        'root',
        '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    $obj = new ASPager\PdoPager(
        new ASPager\ItemsRange(),
        $pdo,
        'table_name'
    );
    echo "<pre>";
    print_r($obj->getItems());
    echo "</pre>";
    echo "<p>$obj</p>";
}
```

## License

The MIT License (MIT). Please see [License File] (https://github.com/dnoegel/php-xdg-base-dir/blob/master/LICENSE) for more information.