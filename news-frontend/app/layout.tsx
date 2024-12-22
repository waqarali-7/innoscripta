"use client";

import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { useState } from "react";
import Navbar from "@/components/Navbar";
import { AuthProvider } from "@/services/context/AuthContext";
import "./globals.css";

export default function RootLayout({ children }: { children: React.ReactNode }) {
  const [queryClient] = useState(() => new QueryClient());

  return (
    <html lang="en">
      <body>
        <AuthProvider>
          <QueryClientProvider client={queryClient}>
            <Navbar /> {/* Add Navbar here */}
            <main>{children}</main>
          </QueryClientProvider>
        </AuthProvider>
      </body>
    </html>
  );
}
