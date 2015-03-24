# Data-preprocessing
Wiki article: [Data pre-processing](http://en.wikipedia.org/wiki/Data_pre-processing)

## Datatype
The datatype of each column is determined based on the majority of the value types.

## Splitting
The dataset class could be used split into 3 (training, validation, testing) different subsets with given ratio's.

### Example
```php
$dataset = new Dataset();
$dataset->setConfig($config);
$dataset->addData($data);
list($traningData, , $testData) = $dataset->split(0.8, 0, 0.2);

```
