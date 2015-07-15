#!/bin/bash

# Copy sources.list
cp -f /vagrant/vagrant-virtualbox-ansible/ansible/sources.list /etc/apt/sources.list

# Update apt information
apt-get update > /dev/null

# Install ansible
apt-get install -y ansible aptitude apt-transport-https > /dev/null

export PYTHONUNBUFFERED=1

# Run the playbook.
echo "Running Ansible provisioner defined in Vagrantfile."
echo "extra-vars: " $2
ansible-playbook -i localhost, --connection=local --extra-vars=${2} /vagrant/vagrant-virtualbox-ansible/${1}
