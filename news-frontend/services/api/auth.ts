// import api from "./axiosInstance";

// export const loginUser = async (email: string, password: string) => {
//   const response = await api.post("/login", { email, password });
//   return response.data;
// };

import axios from 'axios';

const api = axios.create({
  baseURL: 'http://localhost:8000/api',
  headers: {
    'Content-Type': 'application/json',
  },
  withCredentials: true, // Include credentials if needed
});

export const loginUser = async (email: string, password: string) => {
  const response = await api.post('/login', { email, password });
  return response.data;
};

export const registerUser = async (
  name: string,
  email: string,
  password: string,
  password_confirmation: string
) => {
  const response = await api.post("/register", {
    name,
    email,
    password,
    password_confirmation,
  });
  return response.data;
};
