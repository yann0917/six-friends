#!groovy
pipeline {
    agent any
    stages {
        stage('Build') {
            steps {
                echo 'Building..'
            }
        }
        stage('Test') {
            steps {
                echo 'Testing..'
            }
        }
        stage('Deploy') {
            steps {
                echo 'Deploying....'
            }
        }
    }
}

// 正式环境判断
def isOnline() {
    if (env.BRANCH_NAME == 'master' || env.BRANCH_NAME == 'production') {
        return true
    }
    return false
}

// 正式环境A
def isMaster() {
    if (env.BRANCH_NAME == 'master') {
        return true
    }
    return false
}

// 正式环境B
def isProduction() {
    if (env.BRANCH_NAME == 'production') {
        return true
    }
    return false
}

// 模拟环境
def isStaging() {
    if (env.BRANCH_NAME == 'release') {
        return true
    }
    return false
}

// 开发环境
def isDev() {
    if (env.BRANCH_NAME == 'develop') {
        return true
    }
    return false
}
