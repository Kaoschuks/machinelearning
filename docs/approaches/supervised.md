Wiki article: [Supervised learning](http://en.wikipedia.org/wiki/Supervised_learning)

## k-nearest neighbors
Wiki article: [k-nearest neighbors](http://en.wikipedia.org/wiki/K-nearest_neighbors_algorithm)

The k nearest neighbor algortihm is an instance based learning algorithm. This means that on each test vector the algortihm is looking for k nearest neighbors in the training data. In other words it's classifying per verctor (instance).

### Example
```php
$cluster = new KNearestNeighbors();
$cluster->setConfig($config);
$cluster->setTrainingData($traningData);
$cluster->setTestData($testData);
$cluster->test();

print_r($cluster);
```
This example finds which vectors in the given test data has the nearest neighbors in the training data, and prints the cluster objects.

## Decision trees

### Example
```php
# TODO
```
