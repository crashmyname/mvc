<?php

namespace Support;

class Controller {
    function asset($path)
    {
        $baseURL = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
        $baseDir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        $baseURL.=$_SERVER['HTTP_HOST'].$baseDir;

        return $baseURL.'public/'.$path;
    }

    function module($path)
    {
        $baseURL = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
        $baseDir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        $baseURL.=$_SERVER['HTTP_HOST'].$baseDir;

        return $baseURL.'node_modules/'.$path;
    }
    function vendor($path)
    {
        $baseURL = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
        $baseDir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        $baseURL.=$_SERVER['HTTP_HOST'].$baseDir;

        return $baseURL.'vendor/'.$path;
    }

    function base_url()
    {
        if (php_sapi_name() === 'cli-server' || PHP_SAPI === 'cli') {
            $baseURL = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
            $baseDir = rtrim(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']), '/');
            $baseURL .= $_SERVER['HTTP_HOST'] . $baseDir;
            return $baseURL;
        } else {
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
            $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
            $baseUrl = $protocol . $host . '/' . basename(dirname(dirname(__DIR__))); 
            return $baseUrl;
        }
    }

    function pretty_print($data) {
        echo '
        <style>
            .pretty-print {
                background-color: #2d2d2d;
                color: #f8f8f2;
                padding: 15px;
                border-radius: 8px;
                font-family: "Courier New", Courier, monospace;
                line-height: 1.5;
                font-size: 16px;
                max-width: 100%;
                overflow-x: auto;
            }
            .pretty-print .key {
                color: #66d9ef;
            }
            .pretty-print .string {
                color: #a6e22e;
            }
            .pretty-print .number {
                color: #fd971f;
            }
            .pretty-print .bool {
                color: #f92672;
            }
            .pretty-print .null {
                color: #75715e;
            }
            .pretty-print .collapsible {
                cursor: pointer;
                color: #f8f8f2;
                border: none;
                background: none;
                text-align: left;
            }
            .pretty-print .collapsible:after {
                content: " ▼";
            }
            .pretty-print .collapsible.active:after {
                content: " ▲";
            }
            .pretty-print .content {
                display: none;
                margin-left: 20px;
            }
            .pretty-print .content.show {
                display: block;
            }
        </style>
        ';
        echo '
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var coll = document.getElementsByClassName("collapsible");
                for (var i = 0; i < coll.length; i++) {
                    coll[i].addEventListener("click", function() {
                        this.classList.toggle("active");
                        var content = this.nextElementSibling;
                        if (content.style.display === "block") {
                            content.style.display = "none";
                        } else {
                            content.style.display = "block";
                        }
                    });
                }
            });
        </script>
        ';
    
        function format_data($data) {
            $result = '';
            foreach ($data as $key => $value) {
                $result .= '<span class="key">[' . htmlspecialchars($key) . ']</span> => ';
                if (is_array($value) || is_object($value)) {
                    $result .= '<button class="collapsible">Object/Array</button>';
                    $result .= '<div class="content">';
                    $result .= format_data((array) $value);
                    $result .= '</div>';
                } elseif (is_string($value)) {
                    $result .= '<span class="string">"' . htmlspecialchars($value) . '"</span><br>';
                } elseif (is_numeric($value)) {
                    $result .= '<span class="number">' . htmlspecialchars($value) . '</span><br>';
                } elseif (is_bool($value)) {
                    $result .= '<span class="bool">' . ($value ? 'true' : 'false') . '</span><br>';
                } else {
                    $result .= '<span class="null">null</span><br>';
                }
            }
            return $result;
        }
    
        if (is_object($data)) {
            $reflection = new ReflectionClass($data);
            $properties = $reflection->getProperties();
            $formatted_data = [];
            foreach ($properties as $property) {
                $property->setAccessible(true);
                $formatted_data[$property->getName()] = $property->getValue($data);
            }
        } else {
            $formatted_data = $data;
        }

        echo '<div class="pretty-print">';
        echo format_data($formatted_data);
        echo '</div>';
        exit;
    }
}