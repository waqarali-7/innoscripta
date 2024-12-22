# Use Node.js image
FROM node:18-alpine

# Set working directory
WORKDIR /usr/src/app

# Copy package.json and install dependencies
COPY package.json yarn.lock ./
RUN yarn install

# Copy app files
COPY . .

# Expose the port
EXPOSE 3000

# Start the app
CMD ["yarn", "dev"]
