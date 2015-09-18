#!/bin/bash

# Copy resolv.conf (prevent dns problems)
cp -f /vagrant/vagrant-php/ansible/resolv.conf /etc/resolv.conf

# Copy sources.list
cp -f /vagrant/vagrant-php/ansible/sources.list /etc/apt/sources.list

# Update apt information
apt-get update > /dev/null

# Install ansible, https support for apt
apt-get install -y ansible aptitude apt-transport-https > /dev/null

PYTHONUNBUFFERED=1

# Run the playbook.
echo "Running Ansible provisioner defined in Vagrantfile."
echo "extra-vars: " $2
ansible-playbook -i localhost, --connection=local --extra-vars=${2} /vagrant/vagrant-php/${1}
