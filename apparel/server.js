const express= require('express');
const { Pool }  = require('pg');

const HOST = '0.0.0.0';
const PORT = 80;

const app = express();

const pool = new Pool({ user:'postgres', host:'db' });
