# Rule: getimagesize() is discouraged

## Reason

[getimagesize](https://www.php.net/manual/en/function.getimagesize.php) function works only with local and supported streams. 
With introduction of more advanced storages, like AWS S3 or Azure Blob Storage this function will cause issues where file is not accessible.

## How to fix

[getimagesizefromstring](https://www.php.net/manual/en/function.getimagesizefromstring.php) can be used instead to retrieve all the information from file.
This function works with data strings, so you should read the file content using specific adapter before using it.
