#!/bin/bash

# Install ansible
apt-get install -y ansible

export PYTHONUNBUFFERED=1

# Run the playbook.
echo "Running Ansible provisioner defined in Vagrantfile."
ansible-playbook -i localhost, --connection=local --extra-vars=${2} /vagrant/${1}