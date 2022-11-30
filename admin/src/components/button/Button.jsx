export default function Button({ children, ...props }) {
  return (
    <button
      className="inline-block w-full p-1 border-2 border-teal-600 bg-teal-600  hover:bg-teal-700 hover:border-teal-700 rounded-sm transition text-white text-lg  font-semibold font-mono"
      {...props}
    >
      {children}
    </button>
  );
}
