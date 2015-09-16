# dominikzogg/vagrant-php

## Features

 * ubuntu 14.04
 * nginx 1.8

## Switchable features

 * freetds 0.91
 * java 7 (headless)
 * mariadb 10.0
 * memcached 1.4
 * mongodb 3.0
 * nodejs 0.12
 * postgresql 9.4
 * ruby 2.1.5

## Installation

 * [linux][1]
 * [osx][2]
 * [windows][3]

### Plugin

#### Hostmanager

```{.sh}
vagrant plugin install vagrant-hostmanager
```

### vagrant-php

#### register

**important**: call this only onces per project (initial setup).

```{.sh}
cd /path/to/my/project
git submodule add -b v1-ubuntu https://github.com/dominikzogg/vagrant-php.git
```

#### install

after checked out a prepared project or update to the version registred within the project.

```{.sh}
cd /path/to/my/project
git submodule update --init -- vagrant-php
```

#### update

get the newest version of the vagrant-php submodule.

```{.sh}
cd /path/to/my/project
git submodule update --remote -- vagrant-php
```

## Configuration

### vagrant.yml (within your project dir)

```{.yml}
---
hostname: projectname.dev
```

for advanced configuration see the [default configuration][4]

#### supported application

 * contao
 * default
 * drupal
 * lavarel
 * [symfony][5]
 * wordpress

#### supported sharetype

 * native
 * nfs
 * nfs-bindfs

#### supported php versions

If you dlike to change the php version, you need to run `vagrant destroy and vagrant up`.

 * 5.5-original
 * 5.5
 * 5.6
 * 7.0
 * hhvm

### vagrant-user.yml (within your project dir)

This yaml is for user overrides, *do not* commit this file within your project.

## Run

The vagrant setup is in a subdir, which means you need to go there, and call all vagrant commands from there.

```{.sh}
cd /path/to/my/project
cd vagrant-php
vagrant up
vagrant halt
vagrant suspend
vagrant resume
vagrant provision
vagrant ssh
```

## Troubleshooting

 * [all platforms][6]
 * [linux][7]
 * [osx][8]
 * [windows][9]

## Thanks

 * [VMware][10] for the large discount on the [vmware workstation][11] license for testing this setup.
 * [hashicorp][12] for the large discount on the [vagrant-vmware-workstation][13] license for testing this setup.

[1]: doc/installation/linux.md
[2]: doc/installation/osx.md
[3]: doc/installation/windows.md
[4]: vagrant-default.yml
[5]: doc/application/symfony.md
[6]: doc/troubleshooting/allplatforms.md
[7]: doc/troubleshooting/linux.md
[8]: doc/troubleshooting/osx.md
[9]: doc/troubleshooting/windows.md
[10]: https://www.vmware.com
[11]: https://www.vmware.com/products/workstation/features.html
[12]: https://hashicorp.com
[13]: https://www.vagrantup.com/vmware#buy-now
