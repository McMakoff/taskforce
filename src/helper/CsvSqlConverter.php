<?php

namespace taskforce\helper;

use taskforce\exception\ConverterException;

class CsvSqlConverter
{
  protected array $filesToConvert = [];

  public function __construct(string $directory)
  {
    if (!is_dir($directory)) {
      throw new ConverterException('Директории не существует');
    }

    $this->loadCsvFiles($directory);
  }

  public function convertFiles (string $directory)
  {
    foreach ($this->filesToConvert as $key => $file) {
      $this->convertFile($file, $directory);
    }
  }

  private function convertFile (\SplFileInfo $file, string $directory): void
  {
    $fileObject = new \SplFileObject($file->getRealPath());
    $fileObject->setFlags(\SplFileObject::READ_CSV);

    $columns = $fileObject->fgetcsv();

    $values = [];

    while(!$fileObject->eof()) {
      $values[] = $fileObject->fgetcsv();
    }

    $tableName = $file->getBasename('.csv');

    $content = $this->getSqlContent($tableName, $columns, $values);

    $this->saveSqlContent($directory, $tableName, $content);
  }

  private function getSqlContent(string $tableName, array $columns, array $values): string
  {
    $columnParse = implode(',', $columns);
    $sql = "INSERT INTO $tableName ($columnParse) VALUES ";

    foreach ($values as $key => $row) {
      array_walk($row, function(&$value) {
        $value = addslashes($value);
        $value = "'$value'";
      });

      $sql .= '(' . implode(',', $row) . ')';

      if ($key < count($values) - 1) {
        $sql .= ',';
      }
    }

    return $sql;
  }

  private function saveSqlContent(string $directory, string $tableName, $content)
  {
    if (!is_dir($directory)) {
      throw new ConverterException('Директории не существует');
    }

    $fileName = $directory . DIRECTORY_SEPARATOR . $tableName . '.' . 'sql';

    file_put_contents($fileName, $content);
  }

  private function loadCsvFiles (string $directory)
  {
    foreach (new \DirectoryIterator($directory) as $file) {
      if ($file->getExtension() === 'csv') {
        $this->filesToConvert[] = $file->getFileInfo();
      }
    }
  }
}