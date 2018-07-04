#!/usr/bin/env groovy

pipeline {

    agent any

    stages {
        stage('Pre-build') {
          steps {
              echo 'Stopping and removing previous container...'
              sh 'docker rm $(docker ps -f label=mydevice -q)'
          }
        }
        stage('Build') {
            steps {
                echo 'Building...'
                sh 'docker build -t mydevice.tech . '
                sh 'docker run -p 5555:80 -d -l mydevice.tech mydevice.tech'
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