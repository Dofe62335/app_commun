<?php
namespace Dompdf;
spl_autoload_register(function ($class) {
    $prefix = 'Dompdf\\';
    if (strpos($class, $prefix) !== 0) return;
    $base_dir = __DIR__ . '/dompdf/';
    $relative_class = substr($class, strlen($prefix));
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) require $file;
});

class Options {
    private $opts = [];
    public function set($key, $val) { $this->opts[$key] = $val; }
}
class Dompdf {
    public function loadHtml($html) { $this->html = $html; }
    public function setPaper($a, $b) {}
    public function render() {}
    public function stream($name, $opts) { echo $this->html; }
}
