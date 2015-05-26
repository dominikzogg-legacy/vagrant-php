# dominikzogg/vagrant-virtualbox-ansible-symfony

Howto optimize your symfony for good perfomance with vagrant and virtualbox?
Do not write any cache or log to the synced folder.

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