<?php
declare(strict_types=1);

namespace CLSlim\Controllers;

/**
 * Class ActionBase
 *
 * @package CLSlim\Controllers
 */
abstract class ActionBase
{
	/**
	 * @param array $data
	 * @param array $modelFields
	 */
    protected function sanitize(array &$data, array $modelFields): void
    {
        foreach ($data as $field => $value) {
            if (array_key_exists($field, $modelFields)) {
                $dataType = $modelFields[$field];
                if ($dataType{0} === '*') {
                    unset($data[$field]);
                }
            }
        }
    }
}
