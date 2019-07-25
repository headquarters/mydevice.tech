#!/usr/bin/env groovy

pipeline {

    agent any

    stages {
        stage('Build container') {
          steps {
              echo 'Stopping and removing previous container...'
              // send error to dev/null because an error will kill the bulid, but we don't care if the container does not exist
              sh 'docker container stop mydevice.tech 2>/dev/null'
          }
        }
        stage('Build') {
            steps {
                echo 'Building...'
                sh 'docker build -t mydevice.tech . '
                sh 'docker run --name mydevice.tech --rm -p 5555:80 -d mydevice.tech'
            }
        }
        stage('Test') {
            steps {
                echo 'Testing...'
                sh 'curl 127.0.0.1:5555'
            }
        }
    }
}