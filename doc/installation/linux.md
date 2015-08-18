# Installation within linux

## Vagrant

[Download][1] and install the newest version of vagrant.
Use `.deb` for Debian based distributions as, Debian, elementary OS, Linux Mint, Ubuntu.
Use `.rpm` for Fedora, Mageia, OpenSUSE etc.

## Provider

You need at least one of this providers to use vagrant-php.

### Virtualbox

[Download][2] and install the newest version of virtualbox.

#### Automatic suspend on host reboot/shutdown

Add the following lines to `/etc/default/virtualbox` and add every user, which uses virtualbox whitespace separated.
On non Debian based distribution, this file is probably missing, at if, cause it get used if its exists.

```{.sh}
SHUTDOWN_USERS="user1 user2"
SHUTDOWN=savestate
```

### VMWare

[Download][3] and install the newest version of vmware workstation.

Install the vagrant vmware plugin

```{.sh}
vagrant plugin install vagrant-vmware-workstation
```

You need to get a [license][4] and follow the instructions within the mail from HashiCorp.

## Shared Filesystem

### NFS

If you want to use nfs instead of the default shared filesystem of the provider, for example for performance reasons,
or cause the kernel module of the provider does problem, you need to install an nfs server.

#### Debian, elementary OS, Linux Mint, Ubuntu

```{.sh}
apt-get install nfs-kernel-server
```

#### Fedora

```{.sh}
yum install nfs-utils
```

#### Mageia

```{.sh}
urpmi nfs-utils
```

#### OpenSUSE

```{.sh}
zypper install nfs-kernel-server
```

[1]: https://www.vagrantup.com/downloads.html
[2]: https://www.virtualbox.org/wiki/Linux_Downloads
[3]: http://www.vmware.com/products/workstation
[4]: http://www.vagrantup.com/vmware