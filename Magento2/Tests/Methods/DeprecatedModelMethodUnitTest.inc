<?php

$model->getResource()->save($model);

$model->getResource()->load($model, $id);

$model->getResource()->delete($model);

$model->getResource()->myCustomMethod();

$model->myCustomMethod();

$model->anotherMethodWithResource()->save($model);
