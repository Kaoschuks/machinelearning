An important first step in machine learning is preparing the dataset, since this is the foundation of learing your machine. Analyze the dataset, identify the missing values and norrmalize the nominal values are a few actions that need to be addressed before starting to train your system.

## Splitting
The dataset class could be used split into 3 (**training**, **validation**, **testing**) different subsets with given ratio's.

### Example
```php
$dataset = new Dataset();
$dataset->setConfig($config);
$dataset->addData($data);
list($traningData, , $testData) = $dataset->split(0.8, 0, 0.2);

```
