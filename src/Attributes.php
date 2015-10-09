<?php
namespace Code4\Menu;

class Attributes  {

    private $items;

    public function __construct($items = [])
    {
        $this->items = (array) $items;
    }

    /**
     * Dodaje wartość do atrybutu
     * @param $key
     * @param $value
     * @return $this
     */
    public function add($key, $value) {
        if (array_key_exists($key, $this->items)) {
            if (is_array($this->items[$key])) {
                array_push($this->items[$key], $value);
            } else {
                $this->items[$key] .= ' '.$value;
            }
        } else {
            $this->items[$key] = (array) $value;
        }
        return $this;
    }

    /**
     * Usuwa atrybut z listy atrybutów pod wskazanym kluczem
     * @param $key
     * @param null $value
     * @return null
     */
    public function remove($key, $value = null) {
        if (!array_key_exists($key, $this->items)) return null;
        if ($value == null) {
            unset($this->items[$key]);
        } else {
            if (is_array($this->items[$key]) && ($index = array_search($value, $this->items[$key])) !== false) {
                unset($this->items[$key][$index]);
            } else {
                $this->items[$key] = str_replace($value, '', $this->items[$key]);
            }
        }
        return null;
    }

    /**
     * Zastępuje cały atrybut
     * @param $key
     * @param $value
     * @return $this
     */
    public function replace($key, $value) {
        $this->items[$key] = $value;
        return $this;
    }

    /**
     * Zwraca żądany atrybut. Jeżeli atrybut jest tablicą, zrzuca go do stringa.
     * @param $key
     * @param string $separator
     * @return null|string
     */
    public function get($key, $separator = ' ') {
        if (array_key_exists($key, $this->items)) {
            if (is_array($this->items[$key])) {
                return implode($separator, $this->items[$key]);
            }
            return $this->items[$key];
        }
        return null;
    }

    /**
     * Zwraca wszystkie atrybuty w postaci string'u html
     * @return string
     */
    public function all() {
        $all = '';
        foreach($this->items as $key => $value) {
            if (is_numeric($key)) $key = $value;
            $value = implode(' ', (array) $value);
            $all .= !is_null($value) ? $key.'="'.e($value).'" ' : '';
        }
        return $all;
    }


    /**
     * Zwraca pojedyńczy atrybut wskazany kluczem w formacie html
     * @param $key
     * @return string
     */
    public function single($key) {
        $all = '';
        if (array_key_exists($key, $this->items))
        {
            $value = implode(' ', (array) $this->items[$key]);
            $all .= ! is_null($value) ? $key . '="' . e($value) . '" ' : '';
        }
        return $all;
    }

    public function __toString() {
        return $this->all();
    }


}