require 'json'
require 'yaml'

olddirname = File.dirname(File.expand_path(__FILE__)).split(File::SEPARATOR).last()
newdirname = 'vagrant-php'
if olddirname != newdirname
  if ARGV[0] != 'halt' && ARGV[0] != 'destroy'
    print "please call `vagrant halt` to prepare directory rename\n"
    exit 1
  else
    print 'please call `cd .. && git mv ' + olddirname + ' ' + newdirname + ' && cd ' + newdirname + "`\n"
    __END__
  end
end

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
  config.vm.box = 'boxcutter/debian80'

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

  if projectconfig['sharetype'] == 'native'
      config.vm.synced_folder './..', '/vagrant'
  elsif projectconfig['sharetype'] == 'nfs' or projectconfig['sharetype'] == 'nfs-bindfs'
    config.nfs.map_uid = Process.uid
    config.nfs.map_gid = Process.gid
    if projectconfig['sharetype'] == 'nfs-bindfs'
      config.vm.synced_folder './..', '/vagrant-nfs', create: true, nfs: true, nfs_udp: false
      config.bindfs.bind_folder '/vagrant-nfs', '/vagrant'
    else
      config.vm.synced_folder './..', '/vagrant', create: true, nfs: true, nfs_udp: false
    end
  else
    print "no valid sharetype, please take a look into README.md!\n"
  end
  
  # Resources of our box
  # --------------------------------------------------------------------------

  # for virtualbox
  config.vm.provider 'virtualbox' do |v|
    v.name = projectconfig['hostname']
    v.memory = projectconfig['memory']
    v.cpus = 1
    v.customize ['modifyvm', :id, '--natdnshostresolver1', 'on']

    if not Vagrant::Util::Platform.windows?
      # use virtio networkcards on unix hosts
      v.customize ['modifyvm', :id, '--nictype1', 'virtio']
      v.customize ['modifyvm', :id, '--nictype2', 'virtio']
    end
  end

  # for vmware
  config.vm.provider "vmware_fusion" do |v|
    v.vmx['displayname'] = projectconfig['hostname']
    v.vmx['memsize'] = projectconfig['memory']
    v.vmx['numvcpus'] = '1'
    v.vmx['vhv.enable'] = 'TRUE'
  end

  # for parallels
  config.vm.provider "parallels" do |v|
    v.name = projectconfig['hostname']
    v.memory = projectconfig['memory']
    v.cpus = 1
  end

  # Provisioning
  # --------------------------------------------------------------------------
  config.vm.provision 'shell' do |sh|
      sh.path = 'ansible/ansible-on-guest.sh'
      sh.args = ['ansible/playbook.yml', projectconfig.to_json.split(' ').join('\u0020')]
  end
end
