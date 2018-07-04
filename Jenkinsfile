#!/usr/bin/env groovy

pipeline {

    agent {
        dockerfile true
    }

    stages {
        stage('Build') {
            steps {
                echo 'Building...'
                sh 'npm install'
            }
        }
        stage('Test') {
            steps {
                echo 'Testing...'
                sh 'curl 127.0.0.1'
            }
        }
    }
}