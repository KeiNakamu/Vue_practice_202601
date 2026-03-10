// PiniaのdefineStoreをインポート
// defineStoreは「状態管理ストア」を作成するための関数
import { defineStore } from 'pinia'
import axios from 'axios'

// useAuthStoreを定義
// 第一引数'auth'はストアの識別ID
export const useAuthStore = defineStore('auth', {
  // アプリ全体で状態を共有
  state: () => ({
    // ログイン済みなら localStorage から token を取得
    token: localStorage.getItem('token') || null,
    // ログインユーザー情報を保持 初期値: null
    user: null,
  }),

  // 算出プロパティ
  // stateから計算される値
  getters: {
    // tokenが存在すれば（ログイン中）、true
    isLoggedIn: (state) => !!state.token,
  },

  // 状態を変更する関数
  // stateを変更するときはここで行う
  actions: {
    // tokenだけセットする関数
    setToken(token) {
      this.token = token

      // ページリロードしてもログイン状態を保持するため
      localStorage.setItem('token', token)
    },

    // ログイン処理
    // payloadには { token, user } が渡される想定
    login(payload) {
      // Piniaのstateに保存
      this.token = payload.token
      this.user = payload.user

      // 永続化（F5対策）
      localStorage.setItem('token', payload.token)
    },

    // ログアウト処理
    logout() {
      // stateをクリア
      this.token = null
      this.user = null

      // localStorageからも削除
      localStorage.removeItem('token')
    },
  },
})