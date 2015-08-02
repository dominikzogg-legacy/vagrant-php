# symfony

## Allow host access

`app/app_dev.php`

Add a function after the use statements

```{.php}
function checkAllowedIp($remoteAddress)
{
    if(in_array($remoteAddress, array('127.0.0.1', 'fe80::1', '::1'))) {
        return true;
    }
    $matches = array();
    // http://en.wikipedia.org/wiki/Private_network
    if(preg_match('/([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})/', $remoteAddress, $matches) === 1) {
        for($i=1;$i<5;$i++) {
            $matches[$i] = (int) $matches[$i];
        }
        // localhost
        if($matches[1] === 127) {
            return true;
        }
        if($matches[1] === 10) {
            return true;
        }
        if($matches[1] === 172 && $matches[2] >= 16 && $matches[2] <= 31) {
            return true;
        }
        if($matches[1] === 192 && $matches[2] === 168) {
            return true;
        }
    }
}
```

and replace

```{.php}
in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', 'fe80::1', '::1'))
```

with

```{.php}
checkAllowedIp($_SERVER['REMOTE_ADDR'])
```

## Performance optimization

### Modify the kernel

`app/AppKernel.php`

```{.php}
/**
 * @var string
 */
protected $runtimeDir;

...

/**
 * @return string
 */
public function getCacheDir()
{
    return $this->getRuntimeDir() . '/cache/' . $this->environment;
}

/**
 * {@inheritdoc}
 *
 * @api
 */
public function getLogDir()
{
    return $this->getRuntimeDir() . '/logs';
}

/**
 * @return string
 */
protected function getRuntimeDir()
{
    if(null === $this->runtimeDir) {
        $runtimeDirConfigFile = __DIR__ . '/runtime_dir_config.php';
        if(is_file($runtimeDirConfigFile)) {
            $this->runtimeDir = require $runtimeDirConfigFile;
        } else {
            $this->runtimeDir = $this->rootDir;
        }
    }

    return $this->runtimeDir;
}
```

### Change the cache and log dir path

`app/runtime_dir_config.php`

```{.php}
<?php

$relativeUrl = DIRECTORY_SEPARATOR . 'symfony' . DIRECTORY_SEPARATOR . trim(str_replace(DIRECTORY_SEPARATOR, '-', dirname(__DIR__)), '-');

if(function_exists('posix_getuid') && function_exists('posix_getpwuid')) {
    $userID = posix_getuid();
    $userInfo = posix_getpwuid($userID);

    if(is_array($userInfo) && isset($userInfo['dir']) && $userInfo['dir']) {
        return $userInfo['dir'] . $relativeUrl;
    }
}

return sys_get_temp_dir() . $relativeUrl;
```