FROM node:20-alpine

WORKDIR /app

COPY ./src /app

CMD ["sh"]