# Troubleshooting

## Virtualbox

### dhcp private_network fails

```{.sh}
VBoxManage dhcpserver remove --netname HostInterfaceNetworking-vboxnet0
```

## Vagrant

### Message: Errno::ENOENT: No such file or directory - ... vagrant.yml

Did you add the `vagrant.yml` to your project dir?

### vagrant-bindfs

#### Unknown configuration section 'bindfs'.

Please install or update the vagrant plugin `vagrant-bindfs`

### vagrant-hostmanager

#### Unknown configuration section 'hostmanager'.

Please install or update the vagrant plugin `vagrant-hostmanager`


## OSX

### Unable to install due to FFI error

Check if you have installed XCode, if yes, check if you allready started it, and accepted the license.
