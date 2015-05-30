require 'yaml'

projectconfig = YAML.load_file(File.dirname(File.expand_path(__FILE__)) + "/vagrant.yaml")
sshforwardport = Random.rand(10000..20000)

Vagrant.configure(2) do |config|

  # Vagrant box
  # --------------------------------------------------------------------------
  config.vm.box = "debian/jessie64"

  # General settings
  # --------------------------------------------------------------------------
  config.vm.hostname = projectconfig['hostname']

  # Network
  # --------------------------------------------------------------------------
  config.vm.network "private_network", type: "dhcp"
  config.vm.network :forwarded_port, guest: 22, host: sshforwardport, id: "ssh"

  # SSH stuff
  # --------------------------------------------------------------------------
  config.ssh.forward_agent = true

  # Hostmanager
  # --------------------------------------------------------------------------
  config.hostmanager.enabled = true
  config.hostmanager.manage_host = true
  config.hostmanager.ip_resolver = proc do |vm, resolving_vm|
    if hostname = (vm.ssh_info && vm.ssh_info[:host])
      `vagrant ssh -c "/sbin/ifconfig eth1" | grep "inet addr" | tail -n 1 | egrep -o "[0-9\.]+" | head -n 1 2>&1`.split("\n").first[/(\d+\.\d+\.\d+\.\d+)/, 1]
    end
  end

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
    ansible.extra_vars = projectconfig
    ansible.playbook = "ansible/playbook.yml"
  end
end
