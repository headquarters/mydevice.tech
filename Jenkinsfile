#!/usr/bin/env groovy

pipeline {

    agent any

    stages {
        stage('Build container') {
            echo 'Stopping and removing previous container...'
            try {
            sh 'docker container stop mydevice.tech'
            }
            catch (exc) {
                echo 'Missing container error ignored.'
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