import api from "./axiosInstance";

export const fetchProfile = async (token: string) => {
  const response = await api.get("/user", {
    headers: { Authorization: `Bearer ${token}` },
  });
  return response.data;
};

export const updateProfile = async (token: string, updates: object) => {
  const response = await api.post("/user/preferences", updates, {
    headers: { Authorization: `Bearer ${token}` },
  });
  return response.data;
};
