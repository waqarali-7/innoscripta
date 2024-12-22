import { useState } from "react";

interface FieldInputProps<T extends string> {
  label: string;
  items: string[];
  field: T; // Dynamic field name using a generic
  onAdd: (field: T, value: string) => void;
  onRemove: (field: T, value: string) => void;
}

const FieldInput = <T extends string>({
  label,
  items,
  field,
  onAdd,
  onRemove,
}: FieldInputProps<T>) => {
  const [input, setInput] = useState("");

  const handleAdd = () => {
    if (input.trim()) {
      onAdd(field, input.trim());
      setInput("");
    }
  };

  return (
    <div>
      <label className="block font-bold mb-2">{label}:</label>
      <div className="flex items-center space-x-2">
        <input
          type="text"
          value={input}
          onChange={(e) => setInput(e.target.value)}
          placeholder={`Add ${label.toLowerCase()}`}
          className="border p-2 rounded w-2/3"
        />
        <button
          type="button"
          onClick={handleAdd}
          className="bg-green-500 text-white px-3 py-2 rounded hover:bg-green-600"
        >
          Add
        </button>
      </div>
      <div className="flex flex-wrap mt-2 gap-2">
        {items.map((item) => (
          <span
            key={item}
            className="bg-gray-200 text-gray-700 px-2 py-1 rounded flex items-center"
          >
            {item}
            <button
              type="button"
              onClick={() => onRemove(field, item)}
              className="ml-2 text-red-500 hover:text-red-700"
            >
              &times;
            </button>
          </span>
        ))}
      </div>
    </div>
  );
};

export default FieldInput;
