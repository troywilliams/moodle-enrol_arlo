<?php namespace enrol_arlo\Arlo\AuthAPI\Entity;

use IteratorAggregate;
use ArrayIterator;

/**
 * CustomFields Entity.
 *
 * Custom fields represent unstructured user-defined data that can be associated with entities.
 * Each entity can have a collection of typed fields, with the metadata for all available fields
 * being described by the ResourceDescription for that entity.
 *
 * @package enrol_arlo\Arlo\AuthAPI\Entity
 */
class CustomFields implements IteratorAggregate {

    private $fields = [];

    public function addCustomField(Field $field) {
        $this->fields[] = $field;
        return $this;
    }

    public function getIterator() {
        return new ArrayIterator($this->fields);
    }

}
