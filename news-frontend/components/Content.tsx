import DOMPurify from "dompurify"; // Install using npm i dompurify

interface ContentProps {
  content: string;
}

const Content = ({ content }: ContentProps) => {
  const cleanContent = DOMPurify.sanitize(content); // Clean up the HTML

  return (
    <div
      className="prose max-w-full"
      dangerouslySetInnerHTML={{ __html: cleanContent }}
    />
  );
};

export default Content;
