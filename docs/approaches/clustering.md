# Clustering
Wiki article: [Cluster analysis](http://en.wikipedia.org/wiki/Cluster_analysis)

Cluster analysis is the assignment of a set of observations into subsets (called clusters) so that observations within the same cluster are similar according to some predesignated criterion or criteria, while observations drawn from different clusters are dissimilar. Different clustering techniques make different assumptions on the structure of the data, often defined by some similarity metric and evaluated for example by internal compactness (similarity between members of the same cluster) and separation between different clusters. Other methods are based on estimated density and graph connectivity. Clustering is a method of unsupervised learning, and a common technique for statistical data analysis.

## K-Means
Wiki article: [k-means clustering](http://en.wikipedia.org/wiki/K-means_clustering)

The K means clustering algortihm creates k clusters based on the given trainings data. The algortihm works in a few steps:
* Step 1. Immediately after the trainigs data is added (KMeans::setTrainingData) the k clusters are created, where each cluster centroid is picked based on a random vector (forgy), or based on a random value between the column values max and min.
* Step 2. In the next step the training (KMeans::train) of the clusters is repeated until convergion. Each trainings vector is assigned to it's nearest cluster (centroid) based on the squared distance. After all vectors are assigned to a cluster, the cluster centroids are updated based on it's assigned vectors. This process is repeated until the centroid of each cluster hardly moves to multidimensional space.

### Example
```php
$cluster = new KMeans();
$cluster->setConfig($config);
$cluster->setTrainingData($dataset);
$cluster->train();
$cluster->save($pwd . '/kmeans.clusters.yml');
```
This example trains k clusters and saves the centroids to the kmeans.clusters.yml file.
