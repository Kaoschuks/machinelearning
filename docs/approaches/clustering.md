Wiki article: [Cluster analysis](http://en.wikipedia.org/wiki/Cluster_analysis)

Cluster analysis is the assignment of a set of observations into subsets (called clusters) so that observations within the same cluster are similar according to some predesignated criterion or criteria, while observations drawn from different clusters are dissimilar. Different clustering techniques make different assumptions on the structure of the data, often defined by some similarity metric and evaluated for example by internal compactness (similarity between members of the same cluster) and separation between different clusters. Other methods are based on estimated density and graph connectivity. Clustering is a method of unsupervised learning, and a common technique for statistical data analysis.

## K-Means

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
