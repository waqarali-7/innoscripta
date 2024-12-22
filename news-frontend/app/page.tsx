import Link from "next/link";

export default function Home() {
  return (
    <div className="flex items-center justify-center min-h-screen bg-gray-100">
      <div className="text-center bg-white p-8 rounded-lg shadow-lg">
        <h1 className="text-3xl font-bold mb-4 text-gray-800">
          Welcome to News Portal
        </h1>
        <p className="text-gray-600 mb-6">
          Please login or register to access your personalized news feed.
        </p>
        <div className="flex justify-center gap-4">
          <Link href="/login">
            <button className="px-6 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600 transition">
              Login
            </button>
          </Link>
          <Link href="/register">
            <button className="px-6 py-2 bg-green-500 text-white font-semibold rounded hover:bg-green-600 transition">
              Register
            </button>
          </Link>
        </div>
      </div>
    </div>
  );
}
