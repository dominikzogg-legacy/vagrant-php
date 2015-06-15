# dominikzogg/vagrant-virtualbox-ansible

**important**: the host machine, does not need ansible support, all ansible scripts get managed by the client machine.

## Features

 * Debian 8
 * Nginx 1.8
 * Mariadb 10.0
 * PHP 5.6
 * NodeJS 0.12

## Installation

### virtualbox

Download the newest virtualbox version supported by vagrant.

https://www.virtualbox.org/wiki/Downloads

### vagrant

Download the newest vagrant version.

https://www.vagrantup.com/downloads.html

### vagrant plugin

`vagrant plugin install vagrant-hostmanager`

### operating systems specific

#### windows

##### git

https://msysgit.github.io

Windows got no ssh or git support out of the box, by installing git from `msysgit.github.io` you get ssh and a git
support on a easy way.

## Configuration

### vagrant.yml

#### default

```{.yml}
---
hostname: 'default.dev'
application: 'default'
```

#### drupal

```{.yml}
---
hostname: 'drupal.dev'
application: 'drupal'
```

#### symfony

```{.yml}
---
hostname: 'symfony.dev'
application: 'symfony'
```

### ssh

Allow the virtual machine to use the private keys of the host, for example to pull/push within git.

```{.sh}
Host *.dev
    ForwardAgent yes
```

### Suspend the virtual machines on host logout or shutdown

#### linux

Add the following lines to `/etc/default/virtualbox` and add every user, which uses virtualboxm whitespace separated.

```{.sh}
SHUTDOWN_USERS="foo bar"
SHUTDOWN=savestate
```

#### macosx

Copy the script:

`tools/vagrant-suspend` to `/usr/local/bin/vagrant-suspend`

Register the logout hook:

`sudo defaults write com.apple.loginwindow LogoutHook /usr/local/bin/vagrant-suspend`

#### windows

There should be a python solution for windows, but i have no expirience with it.

http://blog.ionelmc.ro/2014/01/04/virtualbox-vm-auto-shutdown

## Optimization

### symfony

#### Modify the kernel

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

#### Change the cache and log dir path

Copy the script:

`app/runtime_dir_config.php.dist` to `app/runtime_dir_config.php`

#### Allow access from host to `app_dev.php`

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