"use client";

import Link from "next/link";
import { useAuth } from "@/services/context/AuthContext";

const Navbar = () => {
  const { token, logout } = useAuth();

  return (
    <nav className="bg-gray-800 p-4 text-white flex justify-between items-center">
      <Link href="/articles" className="text-lg font-bold">
        News Portal
      </Link>
      <div className="flex items-center gap-4">
        {token ? (
          <>
            <Link href="/profile" className="hover:text-gray-300">
              Profile
            </Link>
            <button
              onClick={logout}
              className="bg-red-500 px-3 py-1 rounded hover:bg-red-600"
            >
              Logout
            </button>
          </>
        ) : (
          <>
            <Link href="/login" className="hover:text-gray-300">
              Login
            </Link>
            <Link href="/register" className="hover:text-gray-300">
              Register
            </Link>
          </>
        )}
      </div>
    </nav>
  );
};

export default Navbar;
