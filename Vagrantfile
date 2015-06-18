require 'yaml'
require 'json'

projectconfig = YAML.load_file(File.dirname(File.expand_path(__FILE__)) + "/../vagrant.yml")
sshforwardport = Random.rand(49152..65535)

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
  config.vm.network :forwarded_port, guest: 22, host: sshforwardport, id: "ssh", auto_correct: true

  # SSH stuff
  # --------------------------------------------------------------------------
  config.ssh.forward_agent = true

  # Hostmanager
  # --------------------------------------------------------------------------
  config.hostmanager.enabled = true
  config.hostmanager.manage_host = true
  config.hostmanager.ip_resolver = proc do |vm, resolving_vm|
    if hostname = (vm.ssh_info && vm.ssh_info[:host])
      `vagrant ssh -c "hostname -I"`.split()[1]
    end
  end

  # Resources of our box
  # --------------------------------------------------------------------------

  # for virtualbox
  config.vm.provider "virtualbox" do |v|
    v.memory = 1024
    v.cpus = 1
    v.customize ['modifyvm', :id, '--natdnshostresolver1', 'on']

    if not Vagrant::Util::Platform.windows?
      # use virtio networkcards on unix hosts
      v.customize ['modifyvm', :id, '--nictype1', 'virtio']
      v.customize ['modifyvm', :id, '--nictype2', 'virtio']
    end

    config.vm.synced_folder "./../", "/vagrant", type: "nfs", nfs_udp: false
  end

  # Provisioning
  # --------------------------------------------------------------------------

  config.vm.provision "shell" do |sh|
      sh.path = "ansible/ansible-on-guest.sh"
      sh.args = ["ansible/playbook.yml", JSON.generate(projectconfig)]
    end
end
