#!/bin/bash

# Install ansible
apt-get install -y ansible > /dev/null

export PYTHONUNBUFFERED=1

# Run the playbook.
echo "Running Ansible provisioner defined in Vagrantfile."
echo "extra-vars: " $2
ansible-playbook -i localhost, --connection=local --extra-vars=${2} /vagrant/vagrant-virtualbox-ansible/${1}
