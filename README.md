# dominikzogg/vagrant-php

**important**: the host machine, does not need ansible support, all ansible scripts get managed by the client machine.

## Features

 * debian 8
 * nginx 1.8
 * php 5.6

## Switchable features

 * freetds 0.91
 * java 7 (headless)
 * mariadb 10.0
 * mongodb 3.0
 * nodejs 0.12
 * postgresql 9.4
 * ruby 2.1.5

## Installation

### virtualbox

Download the newest virtualbox version supported by vagrant.

https://www.virtualbox.org/wiki/Downloads

### vmware (fusion on osx, workstation on linux/windows)

https://www.vmware.com/products/fusion/
https://www.vmware.com/products/workstation/

### vagrant

Download the newest vagrant version.

https://www.vagrantup.com/downloads.html

#### required vagrant plugin

```{.sh}
vagrant plugin install vagrant-hostmanager
```

#### optional vagrant plugin

```{.sh}
vagrant plugin install vagrant-bindfs
```

### provider specific

#### vmware fusion

```{.sh}
vagrant plugin install vagrant-vmware-fusion
```

#### vmware workstation

```{.sh}
vagrant plugin install vagrant-vmware-workstation
```

### operating systems specific

#### linux

##### nfs support

```{.sh}
sudo apt-get install nfs-kernel-server
```

#### windows

##### nfs support

```{.sh}
vagrant plugin install vagrant-winnfsd`
```

##### git / ssh client

https://msysgit.github.io

Windows got no ssh or git support out of the box, by installing git from `msysgit.github.io` you get ssh and a git
support on a easy way.

### vagrant-php

#### as a git submodule

##### register

**important**: call this only onces per project (initial setup).

```{.sh}
cd /path/to/my/project
git submodule add -b v1 https://github.com/dominikzogg/vagrant-php.git
```

##### install

after checked out a prepared project or update to the version registred within the project.

```{.sh}
cd /path/to/my/project
git submodule update --init
```

##### update

get the newest version of the vagrant-php submodule.

```{.sh}
cd /path/to/my/project
git submodule update --remote
```

#### as a copy of the project

```{.sh}
cd /path/to/my/project
git clone https://github.com/dominikzogg/vagrant-php.git
cd vagrant-php
git checkout -b v1
rm -r .git
```

## Configuration

### vagrant.yml (within your project dir)

```{.yml}
---
hostname: projectname.dev
application: default
sharetype: nfs
```

for advanced configuration see the [default configuration][1]

#### supported application

 * contao
 * default
 * drupal
 * lavarel
 * symfony
 * wordpress

#### supported sharetype

 * native
 * nfs
 * nfs-bindfs

### vagrant-user.yml (within your project dir)

This yaml is for user overrides, do not commit this file within your project.

### Suspend the virtual machines on host logout or shutdown

#### linux

Add the following lines to `/etc/default/virtualbox` and add every user, which uses virtualboxm whitespace separated.

```{.sh}
SHUTDOWN_USERS="foo bar"
SHUTDOWN=savestate
```

#### macosx

Copy the script:

```{.sh}
sudo cp tools/vagrant-suspend /usr/local/bin/vagrant-suspend
```

Register the logout hook:

```{.sh}
sudo defaults write com.apple.loginwindow LogoutHook /usr/local/bin/vagrant-suspend
```

#### windows

There should be a python solution for windows, but i have no expirience with it.

http://blog.ionelmc.ro/2014/01/04/virtualbox-vm-auto-shutdown

## Applications

 * [symfony][2]

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

### Virtualbox

#### dhcp private_network fails

```{.sh}
VBoxManage dhcpserver remove --netname HostInterfaceNetworking-vboxnet0
```

### Vagrant

#### vagrant-bindfs

##### Unknown configuration section 'bindfs'.

Please install or update the vagrant plugin `vagrant-bindfs`

#### vagrant-hostmanager

##### Unknown configuration section 'hostmanager'.

Please install or update the vagrant plugin `vagrant-hostmanager`

##### Unable to install due to FFI error

###### OSX

Check if you have installed XCode, if yes, check if you allready started it, and accepted the license.

[1]: vagrant-default.yml
[2]: doc/symfony.md
