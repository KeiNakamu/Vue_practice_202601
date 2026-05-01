import axios from "axios";
import { API_BASE_URL } from "@/config/api";

const api = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    "Content-Type": "application/json",
  },
});

// リクエストのヘッダーにトークンを追加
api.interceptors.request.use((config) => {
  const token = localStorage.getItem("token");

  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }

  return config;
});

// 全件取得
export const getTodos = async () => {
  const res = await api.get("/todos");
  return res.data;
};

// 1件作成
export const createTodo = (todo) => api.post("/todos", todo);


// 更新
export const updateTodo = (id, todo) => api.put(`/todos/${id}`, todo);

// 削除
export const deleteTodo = async (id) => {
  try {
    const res = await api.delete(`/todos/${id}`);
    console.log(res.data);

    return res.data;

  } catch (err) {
    if (err.response) {
      console.error(err.response.status);
      console.error(err.response.data.message);
    } else {
      console.error('通信エラー');
    }
    throw err;
  }
};

