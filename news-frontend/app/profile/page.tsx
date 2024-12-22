"use client";

import { useEffect, useState } from "react";
import { useQuery, useMutation } from "@tanstack/react-query";
import { fetchProfile, updateProfile } from "@/services/api/profile";
import { useAuth } from "@/services/context/AuthContext";
import FieldInput from "@/components/FieldInput";
import { Preferences } from "@/types/preferences";
import { UserProfile } from "@/types/user";


const ProfilePage = () => {
  const { token } = useAuth();
  const [formData, setFormData] = useState<Preferences>({
    sources: [],
    categories: [],
    authors: [],
  });

  const [message, setMessage] = useState<{ type: "success" | "error"; text: string } | null>(null);

  // Fetch Profile Data
  const { data: profileData, isLoading, isError } = useQuery<UserProfile>({
    queryKey: ["profile", token],
    queryFn: () => fetchProfile(token as string),
  });

  useEffect(() => {
    if (profileData) {
      setFormData({
        sources: profileData.preferences.sources || [],
        categories: profileData.preferences.categories || [],
        authors: profileData.preferences.authors?.filter((a) => a) || [], // Remove nulls
      });
    }
  }, [profileData]);

  // Update Profile Mutation
  const mutation = useMutation({
    mutationFn: (updates: Preferences) => updateProfile(token as string, updates),
    onSuccess: () => setMessage({ type: "success", text: "Preferences updated successfully!" }),
    onError: () => setMessage({ type: "error", text: "Failed to update preferences." }),
  });

  // Handle adding and removing items
  const addItem = (field: keyof Preferences, value: string) => {
    if (!value?.trim()) return;
    setFormData((prev) => ({
      ...prev,
      [field]: [...prev[field], value.trim()].filter((v) => v),
    }));
  };

  const removeItem = (field: keyof Preferences, value: string) => {
    setFormData((prev) => ({
      ...prev,
      [field]: prev[field].filter((item) => item !== value),
    }));
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    setMessage(null);
    const cleanedData = {
      sources: formData.sources.filter((s) => s),
      categories: formData.categories.filter((c) => c),
      authors: formData.authors.filter((a) => a),
    };
    mutation.mutate(cleanedData);
  };

  if (isLoading) return <p>Loading profile...</p>;
  if (isError) return <p>Error loading profile</p>;

  return (
    <div className="container mx-auto p-4">
      <h1 className="text-3xl font-bold mb-4">Profile</h1>
      <div className="mb-6">
        <p><strong>Name:</strong> {profileData?.name}</p>
        <p><strong>Email:</strong> {profileData?.email}</p>
      </div>

      <form onSubmit={handleSubmit} className="space-y-6">
        {/* Sources */}
        <FieldInput
          label="Preferred Sources"
          items={formData.sources}
          field="sources"
          onAdd={addItem}
          onRemove={removeItem}
        />

        {/* Categories */}
        <FieldInput
          label="Preferred Categories"
          items={formData.categories}
          field="categories"
          onAdd={addItem}
          onRemove={removeItem}
        />

        {/* Authors */}
        <FieldInput
          label="Preferred Authors"
          items={formData.authors}
          field="authors"
          onAdd={addItem}
          onRemove={removeItem}
        />

        {message && (
          <div
            className={`p-2 rounded ${
              message.type === "success" ? "bg-green-100 text-green-700" : "bg-red-100 text-red-700"
            }`}
          >
            {message.text}
          </div>
        )}

        <button
          type="submit"
          className="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
        >
          Save Preferences
        </button>
      </form>
    </div>
  );
};


export default ProfilePage;
