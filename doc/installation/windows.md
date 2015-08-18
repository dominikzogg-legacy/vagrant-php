# Installation within windows

## Vagrant

[Download][1] and install the newest version of vagrant.

## Provider

You need at least one of this providers to use vagrant-php.

### Virtualbox

[Download][2] and install the newest version of virtualbox.

#### Automatic suspend on host reboot/shutdown

There should be a [python solution for windows][3], but i have no expirience with it.

### VMWare

[Download][4] and install the newest version of vmware workstation.

Install the vagrant vmware plugin

```{.sh}
vagrant plugin install vagrant-vmware-workstation
```

You need to get a [license][5] and follow the instructions within the mail from HashiCorp.

## Shared Filesystem

### NFS

If you want to use nfs instead of the default shared filesystem of the provider, for example for performance reasons,
or cause the kernel module of the provider does problem, you need to install the `vagrant-winnfsd` vagrant plugin.

```{.sh}
vagrant plugin install vagrant-winnfsd
```

## git / ssh client

[Download][1] and install the newest version of git. You will get an ssh client as well, which can be used by vagrant.

[1]: https://www.vagrantup.com/downloads.html
[2]: https://www.virtualbox.org/wiki/Downloads
[3]: http://blog.ionelmc.ro/2014/01/04/virtualbox-vm-auto-shutdown
[3]: http://www.vmware.com/products/workstation
[4]: http://www.vagrantup.com/vmware
[5]: https://msysgit.github.io