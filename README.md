# dominikzogg/vagrant-virtualbox-ansible-symfony

This is a simple vagrant setup for develop symfony projects

## Vagrant plugins

```{.sh}
vagrant plugin install vagrant-hostmanager
```

## Vagrant configuration

Add a configuration at `vagrant.yml`

```{.yaml}
---
hostname: "symfony.dev"
relative_document_root: "/web" # "/web" means "/vagrant/web"
index: "app_dev.php"
```

## Symfony modification

### Update your app/AppKernel.php

```{.php}
/**
 * @var string
 */
protected $runtimeDir;

...

/**
 * {@inheritdoc}
 *
 * @api
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

### Add app/runtime_dir_config.php.dist

Use the app/runtime_dir_config.php.dist file of this repo and copy it to app/runtime_dir_config.php.

### Allow all local networks to access `web/app_dev.php`

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