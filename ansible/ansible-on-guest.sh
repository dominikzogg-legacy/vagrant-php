#!/bin/bash

ANSIBLE_PLAYBOOK=$1
EXTRA_VARS=$2

# Install ansible
apt-get install -y ansible

# Run the playbook.
echo "Running Ansible provisioner defined in Vagrantfile."
ansible-playbook -i 'localhost,' "/vagrant/${ANSIBLE_PLAYBOOK}" --extra-vars $EXTRA_VARS --connection=local