"use client";

import { useQuery } from "@tanstack/react-query";
import { useParams, useRouter } from "next/navigation";
import { fetchSingleArticle } from "@/services/api/articles";
import Content from "@/components/Content";
import ProtectedRoute from "@/components/ProtectedRoute";
import Link from "next/link";
import { useState, useEffect } from "react";

const SingleArticle = () => {
  const { id } = useParams();
  const router = useRouter();
  const [token, setToken] = useState<string | null>(null);

  useEffect(() => {
    // Ensure this runs on the client
    setToken(localStorage.getItem("token") || null);
  }, []);

  const { data, isLoading, isError } = useQuery({
    queryKey: ["article", id],
    queryFn: () => fetchSingleArticle(id as string, token as string),
    enabled: !!id && !!token,
    retry: false, // Don't retry invalid article requests
  });

  useEffect(() => {
    if (isError) {
      router.push("/articles");
    }
  }, [isError, router]);

  if (isLoading || !token) return <p>Loading...</p>;

  const article = data?.data || {};

  return (
    <ProtectedRoute>
      <div className="container mx-auto p-4">
        <Link href="/articles" className="flex items-center text-blue-500 hover:underline">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            className="w-5 h-5 mr-2"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 19l-7-7 7-7" />
          </svg>
          Articles
        </Link>
        <h1 className="text-3xl font-bold mb-4">{article.title}</h1>
        {article.url_to_image && (
          <img
            src={article.url_to_image}
            alt={article.title}
            className="w-full max-h-96 object-cover mb-4"
          />
        )}
        <Content content={article.content} />
        <p className="text-sm text-gray-500">Author: {article.author}</p>
        <p className="text-sm text-gray-500">Published at: {article.published_at}</p>
      </div>
    </ProtectedRoute>
  );
};

export default SingleArticle;
