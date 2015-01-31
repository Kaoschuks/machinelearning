# Examples

```php
require 'vendor/autoload.php';

use MachineLearning\DataPreparation\Dataset;
use MachineLearning\Clustering\KMeans;

require_once dirname(__FILE__) . "/datasets/iris.php";

$dataset = new Dataset($data);
$cluster = new KMeans();
$cluster->addTrainingData($dataset);
$cluster->train();

print_r($cluster->clusters);
```
