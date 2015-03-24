The Config class facilitates configuration for an project. This class loads and stores configuration from an YAML file.

### Example (PHP)
```php
$pwd = dirname(__FILE__);

$config = new Config();
$config->load($pwd . "/knn-iris-config.yml");
```

### Example (YAML)
```yml
Dataset:
    remove.missing.values: true
    normalize.data: false
    shuffle.data: true

KNearestNeighbors:
    num.nearest.neighbors: 3
    method: 'regression'
    distance.boosting: true
```
If no configuration file is provided, the classes will fallback on their default configuration.
