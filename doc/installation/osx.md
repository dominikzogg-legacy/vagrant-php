# Installation within osx

## Vagrant

[Download][1] and install the newest version of vagrant.

## Provider

You need at least one of this providers to use vagrant-php.

### Virtualbox

[Download][2] and install the newest version of virtualbox.

#### Automatic suspend on host reboot/shutdown

Copy the logout hook from this repository, make it executable and register it.

```{.sh}
sudo cp tools/vagrant-suspend /usr/local/bin/vagrant-suspend
sudo chmod +x /usr/local/bin/vagrant-suspend
sudo defaults write com.apple.loginwindow LogoutHook /usr/local/bin/vagrant-suspend
```

### VMWare

[Download][3] and install the newest version of vmware fusion.

Install the vagrant vmware plugin

```{.sh}
vagrant plugin install vagrant-vmware-fusion
```

You need to get a [license][4] and follow the instructions within the mail from HashiCorp.

[1]: https://www.vagrantup.com/downloads.html
[2]: https://www.virtualbox.org/wiki/Downloads
[3]: http://www.vmware.com/products/fusion
[4]: http://www.vagrantup.com/vmware