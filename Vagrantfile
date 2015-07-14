require 'json'
require 'yaml'

class ::Hash
    def deep_merge(second)
        merger = proc { |key, v1, v2| Hash === v1 && Hash === v2 ? v1.merge(v2, &merger) : Array === v1 && Array === v2 ? v1 | v2 : [:undefined, nil, :nil].include?(v2) ? v1 : v2 }
        self.merge(second.to_h, &merger)
    end
end

defaultconfig = YAML.load_file(File.dirname(File.expand_path(__FILE__)) + '/vagrant-default.yml')
projectconfig = YAML.load_file(File.dirname(File.expand_path(__FILE__)) + '/../vagrant.yml')
projectconfig = defaultconfig.deep_merge(projectconfig)
sshforwardport = Random.rand(49152..65535)

Vagrant.configure(2) do |config|

  # Vagrant box
  # --------------------------------------------------------------------------
  config.vm.box = 'debian/jessie64'

  # General settings
  # --------------------------------------------------------------------------
  config.vm.hostname = projectconfig['hostname']

  # Network
  # --------------------------------------------------------------------------
  config.vm.network 'private_network', type: 'dhcp'
  config.vm.network :forwarded_port, guest: 22, host: sshforwardport, id: 'ssh', auto_correct: true

  # SSH stuff
  # --------------------------------------------------------------------------
  config.ssh.forward_agent = true

  # Hostmanager
  # --------------------------------------------------------------------------
  config.hostmanager.enabled = true
  config.hostmanager.manage_host = true
  config.hostmanager.ip_resolver = proc do |vm, resolving_vm|
    if hostname = (vm.ssh_info && vm.ssh_info[:host])
      `vagrant ssh -c 'hostname -I'`.split()[1]
    end
  end

  # Synced folder
  # --------------------------------------------------------------------------
  config.vm.synced_folder '.', '/vagrant', disabled: true

  config.nfs.map_uid = Process.uid
  config.nfs.map_gid = Process.gid

  if Vagrant.has_plugin?("vagrant-bindfs") and projectconfig['bindfs']
    config.vm.synced_folder './..', '/vagrant-nfs', create: true, nfs: true, nfs_udp: false
    config.bindfs.bind_folder '/vagrant-nfs', '/vagrant'
  else
    config.vm.synced_folder './..', '/vagrant', create: true, nfs: true, nfs_udp: false
  end

  # Resources of our box
  # --------------------------------------------------------------------------

  # for virtualbox
  config.vm.provider 'virtualbox' do |v|
    v.name = projectconfig['hostname']
    v.memory = 1024
    v.cpus = 1
    v.customize ['modifyvm', :id, '--natdnshostresolver1', 'on']

    if not Vagrant::Util::Platform.windows?
      # use virtio networkcards on unix hosts
      v.customize ['modifyvm', :id, '--nictype1', 'virtio']
      v.customize ['modifyvm', :id, '--nictype2', 'virtio']
    end
  end

  # Provisioning
  # --------------------------------------------------------------------------

  config.vm.provision 'shell' do |sh|
      sh.path = 'ansible/ansible-on-guest.sh'
      sh.args = ['ansible/playbook.yml', projectconfig.to_json.split(' ').join('\u0020')]
    end
end
