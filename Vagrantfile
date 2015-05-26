VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  # Vagrant box
  # --------------------------------------------------------------------------
  config.vm.box = "debian/jessie64"

  # General settings
  # --------------------------------------------------------------------------
  config.vm.hostname = "symfony.dev"

  # Networking stuff
  # --------------------------------------------------------------------------
  config.vm.network "private_network", type: "dhcp"

  # Resources of our box
  # --------------------------------------------------------------------------

  # for virtualbox
  config.vm.provider "virtualbox" do |v|
    v.memory = 1024
    v.cpus = 1
    v.customize ['modifyvm', :id, '--nictype0', 'virtio']
    v.customize ['modifyvm', :id, '--nictype1', 'virtio']
    v.customize ['modifyvm', :id, '--nictype2', 'virtio']

    config.vm.synced_folder "./", "/vagrant", :nfs => true, nfs_udp: false
  end

  # Provisioning
  # --------------------------------------------------------------------------
  config.vm.provision :ansible do |ansible|
    ansible.playbook = "ansible/playbook.yml"
  end
end
