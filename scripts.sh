#!/bin/bash

work_dir=$(pwd)

# Function to install npm dependencies and run the dev script
install_and_run_dev() {
    local dir=$1
    cd $dir
    if [ ! -d ./node_modules ]; then
        npm install --legacy-peer-deps
    fi
    npm run dev
    rm -rf ./node_modules
    cd $work_dir
}

# List of directories
directories=(
    "./code/packages/OnNow/OneStepCheckout"
    "./code/packages/Stores/MyPharma"
    "./code/packages/Stores/MomBaby"
    "./code/packages/Stores/Microbiome"
    "./code/packages/Stores/TruNiagen"
    "./code/packages/Stores/Pendulum"
    "./code/packages/Stores/Azo"
    "./code/packages/Stores/Santiveri"
    "./code/packages/Stores/NeuroAiD"
    "./code/packages/Stores/Cannabs2go"
    "./code/packages/Stores/Calocurb"
    "./code/packages/Webkul/Admin"
    "./code/packages/Webkul/Ui"
)

# Loop through directories and run the function
for dir in "${directories[@]}"; do
    install_and_run_dev $dir
    wait
done