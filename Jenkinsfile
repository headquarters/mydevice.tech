#!/usr/bin/env groovy

pipeline {

    agent {
        agent any
    }

    stages {
        stage('Build') {
            steps {
                echo 'Building...'
                sh 'docker build -t mydevice.tech . '
                sh 'docker run -p 5555:80 -d mydevice.tech'
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