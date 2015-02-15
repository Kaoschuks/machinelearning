# Supervised
Wiki article: [Supervised learning](http://en.wikipedia.org/wiki/Supervised_learning)

## k-nearest neighbors
Wiki article: [k-nearest neighbors](http://en.wikipedia.org/wiki/K-nearest_neighbors_algorithm)

Finds the nearest neighbors of the given test data, in the training data set.

### Usage
Create a new KNearestNeighbors object with three variables:
1. Number of nearest neighbors (3).
2. The classification method (regression). Classification method uses majority voting, regression calculates the average for classification.
3. Distance boosting (TRUE), boost the shortest distances

### Example
```php
require '../vendor/autoload.php';

use MachineLearning\Data\Dataset;
use MachineLearning\Supervised\KNearestNeighbors;

require_once dirname(__FILE__) . "/datasets/iris.php";

$dataset = new Dataset();
$dataset->addData($data);
list($training_data, , $test_data) = $dataset->split(0.8, 0, 0.2);

$cluster = new KNearestNeighbors();
$cluster->addTrainingData($training_data);
$cluster->addTestData($test_data);
$cluster->test();

print_r($cluster->testData->data);

```
This example uses the iris data and splits it in 80% training data and 20% test data.
