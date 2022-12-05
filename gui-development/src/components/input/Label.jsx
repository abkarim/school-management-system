export default function Label({ children, small = false, ...props }) {
  return (
    <label
      className={`${
        !small ? "text-lg" : "text-sm"
      } text-gray-800 font-mono tracking-tight inline-block`}
      {...props}
    >
      {children}
    </label>
  );
}
